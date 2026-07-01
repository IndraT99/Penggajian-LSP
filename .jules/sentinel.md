## 2024-07-01 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) and state validation bypass in PDF generation endpoints (`generatePDF`).
**Learning:** Endpoints returning files/PDFs are highly prone to authorization omissions as developers focus primarily on generating the view instead of standard access control logic. Also obfuscated routes keys using `HashService` isn't an authorization substitute.
**Prevention:** Implement exact matching `employee_id` and strict state validation (`approved_finance` or `paid` state) inside PDF generation methods as you would in normal `show` methods.
