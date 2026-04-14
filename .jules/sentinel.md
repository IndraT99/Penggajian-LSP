## 2024-05-18 - Fix IDOR in PDF generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF`.
**Learning:** Endpoints generating artifacts (like PDFs) using route model binding can easily overlook ownership and state authorization checks if they rely solely on ID obfuscation (like HashIds).
**Prevention:** Always verify explicit ownership and required object state (like statuses 'approved_finance' or 'paid') before serving file artifacts, even when using obfuscated route IDs.
