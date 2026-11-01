
## 2026-11-01 - [Fix Insecure Direct Object Reference (IDOR) in PDF Generation]
**Vulnerability:** Found an IDOR vulnerability in the `generatePDF` method of `KaryawanSlipGajiController`. Any authenticated user could potentially generate and download the payroll PDF of any other user if they knew or guessed the payroll ID, as route model binding does not inherently check ownership.
**Learning:** Endpoints that return files (like generating a PDF) are especially prone to this oversight as developers might focus heavily on the view generation rather than proper access control and ownership verification. Route obfuscation using `HashService` or `HashIdRoute` is also not a substitute for proper authorization.
**Prevention:** To prevent IDOR vulnerabilities when directly accepting objects like `Payroll` in endpoints, always explicitly verify that the object's `employee_id` belongs to the authenticated user and its `status` is finalized (e.g., 'approved_finance', 'paid').
