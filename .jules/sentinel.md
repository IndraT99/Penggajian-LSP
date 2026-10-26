## 2023-10-26 - IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) found in `KaryawanSlipGajiController@generatePDF`. It allowed any authenticated user to view other employees' payrolls because route model binding didn't check ownership.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control. Route obfuscation using `HashService` or `HashIdRoute` is not a substitute for proper authorization.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user, even when using obfuscated IDs. Verify statuses to prevent access to draft records.
