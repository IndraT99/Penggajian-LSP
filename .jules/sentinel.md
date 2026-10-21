## 2024-05-24 - IDOR in PDF Generation
**Vulnerability:** IDOR vulnerability in the generatePDF method allowing unauthorized access to payroll PDFs.
**Learning:** Route model binding does not inherently enforce authorization; endpoints returning files/PDFs are especially prone to this oversight.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user, and verify status fields for finalized data.
