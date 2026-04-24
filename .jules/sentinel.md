## 2024-05-18 - Missing Authorization on Direct Object Reference (IDOR)
**Vulnerability:** The PDF download endpoint `generatePDF(Payroll $payroll)` in `KaryawanSlipGajiController` accepted a direct model reference without verifying if the authenticated user owned the payroll record, allowing unauthorized access to other employees' sensitive payroll data.
**Learning:** Endpoints that return files or direct objects often forget the authorization checks that are correctly applied to the corresponding HTML view endpoints. Route model binding alone does not prevent IDOR.
**Prevention:** Always implement explicit ownership checks (e.g., `$model->user_id === Auth::id()`) and state validations on all controller methods handling sensitive direct object references, particularly file downloads.
