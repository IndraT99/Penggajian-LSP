## 2026-07-05 - [Fix IDOR in KaryawanSlipGajiController generatePDF]
**Vulnerability:** IDOR in `generatePDF` endpoint allowed accessing PDF slips of other employees.
**Learning:** Endpoints returning files/PDFs are prone to IDOR. Authorization must be explicitly checked, even if object is accessed directly via route model binding.
**Prevention:** Always enforce explicit ownership and state checks on endpoints returning direct object references.
