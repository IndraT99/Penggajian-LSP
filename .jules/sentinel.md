## 2024-05-14 - IDOR in PDF Generation
**Vulnerability:** IDOR in `KaryawanSlipGajiController@generatePDF`
**Learning:** Even if the route uses HashIdRoute for obfuscation, endpoints returning files/PDFs must still verify the authenticated user's authorization and ownership of the requested resource.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references.

## 2024-07-16 - IDOR in PDF Generation
**Vulnerability:** IDOR in `KaryawanSlipGajiController@generatePDF`
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control. Route obfuscation using `HashIdRoute` is not a substitute for proper authorization.
**Prevention:** Always explicitly check authorization, ownership against the authenticated user, and status fields (like `approved_finance` or `paid`) for stateful entities.
