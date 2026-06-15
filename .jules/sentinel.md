
## 2024-05-15 - Missing Authorization on PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) / Missing Authorization. The `KaryawanSlipGajiController@generatePDF` method allowed any authenticated user to download any other user's payslip PDF by directly accessing the route with a different Payroll ID. The `show` method had proper checks, but the `generatePDF` method did not.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently overlooked for authorization checks, especially when a related `show` endpoint is properly secured. Developers may mistakenly believe the obfuscated ID (via `HashService`) is sufficient protection.
**Prevention:** Always implement explicit ownership and state checks (e.g., `approved_finance`, `paid`) on endpoints returning direct object references or files, even if the route key is obfuscated. Never rely on route obfuscation as a substitute for proper authorization.
