## 2024-07-13 - IDOR Vulnerability on PDF Endpoint

**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF download endpoint `KaryawanSlipGajiController@generatePDF` due to lack of ownership and state verification. Any authenticated user could download any payroll slip, including drafts.

**Learning:** Endpoints returning files or PDFs are especially prone to this oversight as developers might focus on view generation rather than access control, ignoring direct model ID routing without explicit check. Route obfuscation using `HashService` or `HashIdRoute` is not a substitute for proper authorization.

**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references. When objects use a `status` field, authorization checks must ensure the record is finalized or publicly available.
