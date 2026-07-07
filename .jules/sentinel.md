## 2024-07-07 - Insecure Direct Object Reference in PDF Generation Endpoint
**Vulnerability:** IDOR vulnerability in KaryawanSlipGajiController's generatePDF method, allowing authenticated users to download PDF slips of other employees without authorization checks.
**Learning:** Endpoints returning files/PDFs are especially prone to missing authorization checks, as developers might focus on view generation rather than access control.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references, even if the objects are obfuscated using HashIds or similar, especially for file/PDF downloads.
