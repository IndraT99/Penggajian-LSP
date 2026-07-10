## 2024-07-10 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on an endpoint returning a file/PDF (`generatePDF`). The route obfuscation using `HashService` or `HashIdRoute` is not a substitute for proper authorization.
**Learning:** Even if an object is accessed directly via route model binding and the ID is obfuscated, always explicitly check authorization and ownership against the authenticated user. Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references, including file and PDF downloads.
