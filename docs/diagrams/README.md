# Diagrams — SkinSync

This folder contains PlantUML sources for Level 0, Level 1 and Level 2 DFD diagrams.

Files
- `simple-dfd-level0.puml` — Level 0 (high-level actors, external services)
- `simple-dfd-level1.puml` — Level 1 (major subsystems: bookings, users, payments, notifications)

Level 2 diagrams (detailed subsystems)
- `dfd-level2-process-bookings.puml` — Validate / availability / assign / confirm / reschedule
- `dfd-level2-manage-users.puml` — Signup / auth / profile / roles
- `dfd-level2-handle-payments.puml` — Tokenize card, charge token, GCash QR flow, webhook, staff confirm
- `dfd-level2-send-notifications.puml` — Template, queue, send, retry
- `dfd-level2-reporting-management.puml` — Aggregation, reports, dashboard
- `dfd-level2-file-management.puml` — Upload, store, generate URLs, lifecycle
- `dfd-level2-realtime-assignments-checkins.puml` — Assignments, realtime notify, accept/reject, check-in

How to render
- Install Java and PlantUML jar locally, then run (from PowerShell):

```powershell
# from project root
java -jar plantuml.jar docs/diagrams/*.puml
```

This will generate PNGs next to each `.puml` file.

Notes
- The PlantUML server (https://www.plantuml.com) may be rate-limited; local rendering is recommended for reliability.
- If you want, I can generate the PNGs locally on your machine (requires Java + PlantUML jar). I can guide you or run the commands here if you want me to execute them.
