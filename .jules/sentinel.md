## 2024-06-02 - [Insecure Direct Object Reference (IDOR) in PDF Generation]
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` allowed any authenticated user to view any other user's payroll slip by providing the payroll ID, due to a lack of ownership checks before generating the PDF.
**Learning:** Endpoints that generate files or PDFs frequently omit authorization checks because developers often focus on the generation logic instead of access controls. This is a common pattern for IDOR vulnerabilities.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references, such as files and PDFs, to verify authorization against the authenticated user before performing the action.
