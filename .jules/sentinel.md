## 2024-05-14 - Prevent IDOR on slip gaji and Secure Utility Routes
**Vulnerability:**
1. Insecure Direct Object Reference (IDOR) on PDF generation for slip gaji. Unauthenticated users or other employees could directly download any employee's slip gaji if they know the payroll ID, which exposes sensitive financial data.
2. Unauthenticated access to sensitive utility routes (`/setup-database` and `/fix-ssl`) that expose artisan commands and could be used for denial-of-service or database manipulation.
**Learning:**
1. The route obfuscation or ID hashing does not replace proper authorization checks. Always verify ownership and state (e.g. `approved_finance` or `paid`) on endpoints returning direct object references like PDFs.
2. Diagnostic routes and setup routes used during deployment or debugging are often left exposed in production without auth middlewares, causing significant risks.
**Prevention:**
1. Always apply explicit authorization checks against the authenticated user and their models in the controller before proceeding with data retrieval and formatting, especially for sensitive documents.
2. Include all utility, debugging, and setup routes under strict middleware groups (e.g. `auth` and `role:admin`) if they must exist in the application code, or remove them entirely from production builds.