# Service Promo Branch Restriction - Implementation

## Overview
Service promos are now strictly branch-specific. Clients can only apply promo codes that belong to the branch they selected for their booking.

## Changes Made

### Backend Validation (`ClientController::validatePromo`)

**Previous Behavior:**
- Promos with `branch_id = NULL` (global promos) could be used at any branch
- Promos with a specific `branch_id` only worked at that branch
- If no branch was selected, promo validation still proceeded

**New Behavior (Strict Branch Validation):**
1. **Branch Selection Required**: Client must select a branch before applying promo
2. **No Global Promos**: Promos must have a `branch_id` assigned
3. **Exact Match Required**: Promo's `branch_id` must match the selected booking branch
4. **Clear Error Messages**: Users get specific feedback about why promo failed

### Validation Flow

```
Client enters promo code
    ↓
1. Check if promo exists and is active
    ↓
2. Check if branch is selected → If NO: "Please select a branch first"
    ↓
3. Check if promo has branch_id → If NO: "This promo is not assigned to any branch"
    ↓
4. Check if promo branch matches selected branch → If NO: "This promo is not valid for the selected branch"
    ↓
5. Check date range (start/end dates)
    ↓
6. Check service/package eligibility
    ↓
7. Calculate and apply discount ✅
```

## Code Changes

### File: `app/Http/Controllers/ClientController.php`

**Location**: `validatePromo()` method (lines ~598-620)

**Changes**:
```php
// OLD CODE (Allowed global promos):
if ($promo->branch_id && $promo->branch_id != $branchId) {
    return response()->json(['valid' => false, 'message' => 'Promo not valid for selected branch.'], 400);
}

// NEW CODE (Strict branch validation):
// Branch restriction - STRICT: Promo must belong to the selected branch
if (!$branchId) {
    return response()->json(['valid' => false, 'message' => 'Please select a branch first.'], 400);
}

if (!$promo->branch_id) {
    return response()->json(['valid' => false, 'message' => 'This promo is not assigned to any branch.'], 400);
}

if ($promo->branch_id != $branchId) {
    return response()->json(['valid' => false, 'message' => 'This promo is not valid for the selected branch.'], 400);
}
```

## Error Messages

| Scenario | Error Message |
|----------|---------------|
| No branch selected | "Please select a branch first." |
| Promo has no branch_id | "This promo is not assigned to any branch." |
| Promo branch doesn't match | "This promo is not valid for the selected branch." |
| Promo not found | "Promo code not found or inactive." |
| Promo not started yet | "Promo is not yet active." |
| Promo expired | "Promo has expired." |
| Wrong service | "Promo does not apply to this service." |
| Wrong package | "Promo does not apply to selected package." |

## How It Works

### Example Scenarios

#### ✅ Scenario 1: Valid Promo (Success)
```
Client selects: Branch A
Client enters promo: "BRANCH-A-20OFF"
Promo details: branch_id = 1 (Branch A), discount = 20%
Result: ✅ Promo applied successfully
```

#### ❌ Scenario 2: Wrong Branch
```
Client selects: Branch B
Client enters promo: "BRANCH-A-20OFF"
Promo details: branch_id = 1 (Branch A), discount = 20%
Result: ❌ "This promo is not valid for the selected branch."
```

#### ❌ Scenario 3: No Branch Assigned to Promo
```
Client selects: Branch A
Client enters promo: "GLOBAL-PROMO"
Promo details: branch_id = NULL, discount = 10%
Result: ❌ "This promo is not assigned to any branch."
```

#### ❌ Scenario 4: No Branch Selected
```
Client selects: (Nothing)
Client enters promo: "BRANCH-A-20OFF"
Result: ❌ "Please select a branch first."
```

## Frontend Integration

### Booking Form (`resources/views/Client/booking.blade.php`)

The promo validation happens automatically when:
1. Client types in promo code field (debounced, 600ms delay)
2. Client changes branch, service, or package selection

**JavaScript validation** (lines ~1208-1240):
```javascript
function validatePromoCode() {
    var code = promoInput.value.trim();
    var params = new URLSearchParams();
    params.append('code', code);
    params.append('branch_id', branchSelect.value || '');  // ← Passes branch_id
    params.append('service_id', serviceSelect.value || '');
    params.append('package_id', packageSelect.value || '');
    
    fetch('/api/promo/validate?' + params.toString())
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                // Show discounted price
            } else {
                // Show error message
            }
        });
}
```

## Database Structure

### Promos Table
```sql
CREATE TABLE `promos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `discount` decimal(5,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `branch_id` bigint unsigned DEFAULT NULL,  -- ← MUST be set (no NULL allowed now)
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promos_branch_id_foreign` (`branch_id`),
  CONSTRAINT `promos_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
);
```

### Promo-Service Relationship
```sql
CREATE TABLE `promo_service` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promo_id` bigint unsigned NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `promo_service_promo_id_foreign` (`promo_id`),
  KEY `promo_service_service_id_foreign` (`service_id`)
);
```

## Admin/Staff Implications

### Creating Promos
- **REQUIRED**: Must assign a branch when creating a promo
- **branch_id field**: Cannot be left empty or NULL
- Each promo is exclusive to one branch
- If you want the same promo at multiple branches, create separate promo codes

### Managing Promos
Staff should create branch-specific promos:
- Branch A Promo: `BRANCHA-SUMMER20` (branch_id = 1)
- Branch B Promo: `BRANCHB-SUMMER20` (branch_id = 2)
- Branch C Promo: `BRANCHC-SUMMER20` (branch_id = 3)

## Testing

### Test Cases

1. **Test Valid Promo at Correct Branch**
   - Select Branch A
   - Enter promo code for Branch A
   - Expected: Discount applied ✅

2. **Test Promo at Wrong Branch**
   - Select Branch B
   - Enter promo code for Branch A
   - Expected: Error "This promo is not valid for the selected branch." ❌

3. **Test Promo Without Branch Selection**
   - Don't select any branch
   - Enter any promo code
   - Expected: Error "Please select a branch first." ❌

4. **Test Global Promo (No Branch Assigned)**
   - Select any branch
   - Enter promo with branch_id = NULL
   - Expected: Error "This promo is not assigned to any branch." ❌

5. **Test Service-Specific Promo**
   - Select Branch A
   - Select Service not in promo's service list
   - Enter promo for Branch A
   - Expected: Error "Promo does not apply to this service." ❌

## Benefits

✅ **Clear Branch Association**: Each promo clearly belongs to one branch
✅ **No Confusion**: Clients can't accidentally use wrong branch promos
✅ **Better Control**: Each branch can manage its own promotions
✅ **Accurate Reporting**: Easy to track which branch generates promo sales
✅ **Fair Competition**: Branches maintain their own promotion strategies

## Migration Notes

### Existing Promos with NULL branch_id
If you have existing promos with `branch_id = NULL` in your database:

**Option 1**: Assign them to specific branches
```sql
UPDATE promos SET branch_id = 1 WHERE code = 'GLOBALPROMO';
```

**Option 2**: Deactivate them
```sql
UPDATE promos SET active = 0 WHERE branch_id IS NULL;
```

**Option 3**: Create separate codes for each branch
```sql
-- Duplicate promo for each branch
INSERT INTO promos (code, title, description, discount, branch_id, active)
SELECT CONCAT(code, '-B1'), title, description, discount, 1, active
FROM promos WHERE branch_id IS NULL;

INSERT INTO promos (code, title, description, discount, branch_id, active)
SELECT CONCAT(code, '-B2'), title, description, discount, 2, active
FROM promos WHERE branch_id IS NULL;

-- Then deactivate originals
UPDATE promos SET active = 0 WHERE branch_id IS NULL;
```

## API Endpoint

### POST `/api/promo/validate`

**Request Parameters**:
- `code` (required): Promo code to validate
- `branch_id` (required): Selected branch ID
- `service_id` (optional): Selected service ID
- `package_id` (optional): Selected package ID

**Response (Success)**:
```json
{
  "valid": true,
  "message": "Promo applied",
  "discount_pct": 20,
  "discount_amount": 400.00,
  "final_price": 1600.00,
  "base_price": 2000.00,
  "promo_title": "20% Off Summer Special"
}
```

**Response (Error)**:
```json
{
  "valid": false,
  "message": "This promo is not valid for the selected branch."
}
```

## Conclusion

The promo system is now strictly branch-specific, ensuring:
- Clear ownership of promotions per branch
- No confusion about promo applicability
- Better control and tracking of promotional campaigns
- Improved user experience with clear error messages

**Status**: ✅ Implemented and Active
**Date**: November 1, 2025
