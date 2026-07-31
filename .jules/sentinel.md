## 2024-03-24 - Missing Authorization on PDF Generation Endpoint
**Vulnerability:** The `/karyawan/slip-gaji/{payroll}/pdf` endpoint (in `KaryawanSlipGajiController@generatePDF`) did not check if the requested `$payroll` actually belonged to the authenticated user's employee ID, nor did it check if the payroll status was final (e.g. `approved_finance` or `paid`).
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control. Route obfuscation using `HashService` or `HashIdRoute` is not a substitute for proper authorization.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references, even if the route uses obfuscated IDs.
