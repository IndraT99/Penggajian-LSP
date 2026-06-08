## 2026-06-08 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF` where any authenticated user could download another user's salary slip.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control, even when route model binding is used.
**Prevention:** Always explicitly check authorization, ownership, and state checks against the authenticated user on endpoints returning direct object references.
