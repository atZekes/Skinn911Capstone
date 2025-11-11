# Conversation Notes — SkinSync DFD & Payments

Date: 2025-11-11
Participants: You (repo owner) and dev pairing assistant

## Summary of decisions
- Level 0 was simplified to be high-level and abstract. Granular UI flows were removed and consolidated.
- CEO analytics was removed from Level 0 at your request.
- Payment handling clarified:
  - The system saves card tokens locally (card vault) — tokenization recommended.
  - GCash is an external QR-based flow; client scans QR and GCash notifies staff to confirm payment.
  - No external full-payment gateway integration is required.
- "Assignments" = system assigns staff to bookings. "Check-ins" = staff marks client arrival.

## Files added/updated
- Updated: `PlantUML/simple-dfd-level0.puml` (consolidated Level 0, removed CEO analytics, added GCash + card vault notes)
- Updated: `PlantUML/simple-dfd-level1.puml` (added GCash external entity and detailed payment flows, tokenization note)
- Added: `docs/payment_guidance.md` (PCI/tokenization guidance and mapping to DFD levels)
- Added Level 2 diagrams (detailed breakdowns):
  - `PlantUML/dfd-level2-process-bookings.puml`
  - `PlantUML/dfd-level2-manage-users.puml`
  - `PlantUML/dfd-level2-handle-payments.puml`
  - `PlantUML/dfd-level2-send-notifications.puml`
  - `PlantUML/dfd-level2-reporting-management.puml`
  - `PlantUML/dfd-level2-file-management.puml`
  - `PlantUML/dfd-level2-realtime-assignments-checkins.puml`

## Important notes and risks
- PCI compliance: storing card tokens still requires careful handling (encryption, access controls). Consider a third-party tokenization provider to reduce scope.
- Webhooks: GCash webhook endpoints must be idempotent and logged; add reconciliation if webhooks are missed.
- Concurrency: Booking check-and-reserve must be atomic (DB transactions / locking or optimistic concurrency control) to avoid double-booking.

## Next recommended actions
1. Implement Level 3 for high-risk flows (suggested order):
   - `Handle Payments` (tokenize, charge, webhook processing, staff confirmation)
   - `Process Bookings` (atomic check-and-reserve sequence)
2. Add a webhook endpoint and `payment_logs` migration in Laravel to capture GCash notifications (I can scaffold this).
3. Configure local PlantUML rendering (Java + PlantUML jar) to preview diagrams without using plantuml.com.
4. Add an operational checklist for payment handling (encryption, backups, rotation, access restrictions).

## Where to find these notes
- Saved at: `docs/conversation_notes.md` in the repository root.

---
End of conversation summary.


