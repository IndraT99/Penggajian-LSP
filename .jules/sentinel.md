## 2024-05-18 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF download endpoints. Users could download other users' PDF files.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently prone to IDOR because developers focus on the view generation rather than access control. Route model binding obfuscation using HashIdRoute is not a substitute for proper authorization. Always check ownership and status.
**Prevention:** Explicitly check authorization and ownership against the authenticated user on all file generation/download endpoints. Confirm the status of the requested object as well.
