
## 2024-07-26 - Missing Authorization on PDF Generate Endpoint (IDOR)
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF` due to missing ownership and status checks. A user could potentially download other employees' payroll slips if they guessed the ID.
**Learning:** Endpoints that return files (like PDFs) are often overlooked for authorization checks, as developers might focus on the view generation rather than access control. Route model binding or ID obfuscation is not a substitute for proper authorization.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user for *all* endpoints that access or return sensitive resources, especially those returning files or documents. Ensure status checks are also implemented to prevent access to draft or unavailable records.
