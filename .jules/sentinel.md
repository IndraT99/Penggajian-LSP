## 2025-06-04 - Fix IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF`. The endpoint generated a PDF for any `Payroll` object passed in the route model binding without checking if the payroll actually belonged to the authenticated user.
**Learning:** Endpoints returning files or streams (like PDFs) are often overlooked for access control checks compared to typical views. Even if obfuscated IDs are used, missing authorization checks can still lead to unauthorized access to sensitive documents.
**Prevention:** Always implement explicit ownership authorization checks (e.g., verifying `$model->user_id === Auth::id()`) inside endpoints that stream or download files, just as you would for normal endpoints.
