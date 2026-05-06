## 2024-05-16 - Prevent IDOR on Salary Slip PDF Generation
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` accepted a `Payroll` model ID and directly generated a PDF without validating if the authenticated user was the owner of that payroll record, leading to an Insecure Direct Object Reference (IDOR).
**Learning:** Endpoints that return direct file downloads or streams often bypass standard view-level authorization checks if developers assume the obfuscated route key (via `HashService`) provides sufficient security.
**Prevention:** Always implement explicit ownership (`$model->owner_id === Auth::user()->id`) and status checks on endpoints returning direct object references, regardless of route obfuscation techniques.
