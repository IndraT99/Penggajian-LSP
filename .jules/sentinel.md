## 2024-04-23 - Critical IDOR on PDF Generation Endpoint
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` allowed direct object reference without ownership verification. Any authenticated user could potentially download other employees' salary slips by iterating through `Payroll` IDs.
**Learning:** Route model binding and obfuscated IDs (`HashService`) are NOT a replacement for explicit authorization checks on sensitive direct object references.
**Prevention:** Always verify object ownership against the authenticated user and validate object state before serving sensitive data or file downloads, even if route parameters appear obfuscated.
