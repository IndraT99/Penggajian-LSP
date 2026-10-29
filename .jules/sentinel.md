## 2024-05-18 - Missing IDOR Check in PDF Generation Endpoint

**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` accepted a `Payroll` model directly but failed to check if the payroll belonged to the currently authenticated user, or if its status was valid to be downloaded, allowing unauthorized access (IDOR) to other users' slip gaji PDFs.
**Learning:** Even if models are passed via route model binding and perhaps route obfuscation is used, it does not guarantee authorization. We must always perform explicit ownership checks and data availability checks (e.g. status) on endpoints that return resources like files or PDFs.
**Prevention:** Apply rigorous authorization checks (e.g. `$payroll->employee_id === $authenticatedUserEmployeeId`) and validate state (e.g. `in_array($payroll->status, ['approved_finance', 'paid'])`) on all endpoints that return sensitive data or files. Route obfuscation should never be a substitute for explicit authorization.
