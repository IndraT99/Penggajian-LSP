## 2024-05-15 - [IDOR in PDF Generation Endpoint]
**Vulnerability:** IDOR (Insecure Direct Object Reference) in `KaryawanSlipGajiController@generatePDF`. The endpoint allowed users to download payroll PDFs using arbitrary IDs without verifying if the payroll record belonged to the authenticated user's employee profile or if the payroll was in a finalized state.
**Learning:** Route obfuscation or focusing on view generation rather than access control can lead to endpoints returning files/PDFs bypassing authorization and ownership checks.
**Prevention:** Always explicitly check authorization, ownership, and state (e.g., status field) against the authenticated user for endpoints returning direct object references, even if the objects are accessed via route model binding or obfuscated IDs.
