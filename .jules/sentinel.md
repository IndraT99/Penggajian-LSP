
## 2025-02-14 - Fix IDOR in PDF Generation Endpoint
**Vulnerability:** The `generatePDF` endpoint in `KaryawanSlipGajiController` was vulnerable to Insecure Direct Object Reference (IDOR). Any authenticated employee could fetch the salary slip PDF of another employee because there was no authorization check verifying that the generated PDF matched the authenticated user's ID.
**Learning:** Route obfuscation (like `HashIdRoute`) is not sufficient to prevent unauthorized access. Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control. Always check both authorization (ownership) and state (e.g. status) when dealing with direct object references.
**Prevention:** Explicitly verify that the requested entity belongs to the authenticated user and possesses the correct state (e.g., `approved_finance` or `paid`) in all file-serving endpoints just as you would for normal view routes.
