## 2026-03-19 - [Insecure Direct Object Reference in PDF Generation]
**Vulnerability:** IDOR vulnerability in KaryawanSlipGajiController's generatePDF method, allowing any authenticated user to view other employees' payslips by guessing their IDs.
**Learning:** The application lacked explicit ownership authorization checks before rendering sensitive PDF documents, trusting that the user ID provided in the route was the authenticated user's ID without verifying it.
**Prevention:** Always verify that resource endpoints explicitly check ownership against the authenticated user's ID before generating or returning sensitive documents or data.
