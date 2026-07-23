## 2024-07-23 - Prevent IDOR in PDF Generation
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` allowed any authenticated user to download any other user's payslip PDF by simply altering the requested payroll ID.
**Learning:** Endpoints that generate or return files (like PDFs) are highly susceptible to IDOR if developers focus solely on the view generation logic and overlook authorization checks. Route obfuscation (`HashIdRoute`) is not sufficient protection.
**Prevention:** Always implement explicit ownership checks (`$model->user_id === auth()->id()`) and state/status checks before processing or returning sensitive resources, especially files.
