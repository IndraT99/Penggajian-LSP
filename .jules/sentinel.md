## 2024-09-04 - IDOR on PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint for salary slips (`KaryawanSlipGajiController@generatePDF`). Any authenticated employee could access other employees' salary slip PDFs by manipulating the route parameter.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control.
**Prevention:** Even if an object is accessed directly via route model binding, always explicitly check authorization and ownership against the authenticated user. Ensure status checks are also verified if the entity has a state, similar to how it's handled in `show()` methods.
