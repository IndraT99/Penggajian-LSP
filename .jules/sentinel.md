## 2025-06-22 - [IDOR in PDF Generation]
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` allowed any authenticated user to download any payroll PDF by manipulating the payroll ID in the route, without checking ownership or status.
**Learning:** Endpoints returning files (like PDFs) or streaming downloads often overlook standard authorization checks because developers focus on the view generation logic. Route model obfuscation (if present) does not mitigate this risk.
**Prevention:** Always implement explicit ownership (`$model->user_id === $currentUser->id`) and state validation (`status` check) for direct object references on all endpoints, including file downloads.
