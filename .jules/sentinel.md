## 2024-05-18 - Missing Access Controls on Generated PDFs
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF download endpoint (`KaryawanSlipGajiController@generatePDF`). Any authenticated user could potentially download other employees' payslips if they guessed the ID.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control, especially when using Route Model Binding, even if route keys are obfuscated.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user on all file/PDF return endpoints, and check that the underlying resource is in a finalized/available state.
