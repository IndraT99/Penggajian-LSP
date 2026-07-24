
## 2024-07-24 - Missing Access Control on PDF Generation Endpoint
**Vulnerability:** IDOR vulnerability in `KaryawanSlipGajiController::generatePDF` where any user could download payroll PDFs for other employees by passing a different payroll ID in the route.
**Learning:** Endpoints that generate or return files (like PDFs) are often overlooked for access control checks compared to standard view endpoints. Developers might assume that because the ID is obfuscated or the user shouldn't know it, it's secure.
**Prevention:** Always enforce explicit ownership and state checks (e.g., status == 'approved') on endpoints returning direct object references, including file downloads. Route obfuscation (like `HashIdRoute`) does not replace authorization.
