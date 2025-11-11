# Payment Guidance — SkinSync

This document explains how payments are represented in the DFD diagrams and gives lightweight guidance about storing card details and handling the GCash QR flow.

## Overview (as reflected in Level 1 DFD)
- Saved card (card vault): Clients can save card details which must be tokenized and stored as a token in the database. The DFD shows this as `Client -> Handle Payments -> Database`.
- Card payments: The system can initiate card payments using the saved token (server-side), then record the payment status in DB and notify staff/client.
- GCash QR flow: For GCash QR payments, the client scans an external QR (GCash). The payment processing happens outside the system (GCash). GCash then notifies staff (or the system) that payment was made; the staff confirms receipt.

## Security / PCI considerations
- Do NOT store raw PAN (primary account number) or CVV in your database or logs.
- Prefer using a PCI-compliant tokenization service or payment provider vault (e.g., Stripe, Adyen, PayMongo, or local PSPs with tokenization) which returns a token you store.
- If you must store card tokens locally, ensure:
  - Tokens are limited-scope (not raw card data).
  - Access controls and encryption are applied to the DB fields holding tokens.
  - You understand your PCI scope — storing tokens may still bring some obligations.
- Never log card numbers or CVV. Mask any display of card numbers (e.g., `**** **** **** 4242`).

## GCash QR specifics (existing behaviour)
- The system provides a QR (or a static QR is scanned) outside the system.
- The payment is executed via GCash mobile app — SkinSync does not process the transaction.
- The external provider (GCash) should notify the staff or call a webhook to SkinSync. In your setup, GCash notifies staff to confirm payment.
- Map this flow in Level 2 for the Payments process: "Provide QR" -> "GCash processes payment" -> "GCash notifies staff / webhook" -> "Staff confirms" -> "Store payment status in DB".

## Recommended next steps
- Integrate with a tokenization provider if you haven't yet — this significantly reduces compliance burden.
- Add a Level 2 diagram for `Handle Payments` showing the steps: Tokenize card, Charge token, Provide QR, Receive webhook, Staff confirm, Store status.
- Add an operational checklist: encryption at rest for DB fields, strict DB access roles, encrypted backups, and audit logging for payment operations.

## Mapping to diagrams
- Level 0: high-level indicator that SkinSync interacts with payment systems (we show GCash external and internal saved-card handling as DB writes).
- Level 1: current file `PlantUML/simple-dfd-level1.puml` shows card token storage and the GCash QR flow plus staff confirmation.
- Level 2: decompose `Handle Payments` into sub-processes (tokenize, charge, provide QR, reconcile/confirm).

If you want, I can:
- Create a Level 2 `Handle Payments` PlantUML that shows the webhook and staff confirmation steps.
- Add a small checklist (technical tasks) to the repo for implementing tokenization and webhooks.
