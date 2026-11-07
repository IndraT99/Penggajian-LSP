## $(date +%Y-%m-%d) - Prevent IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint `generatePDF(Payroll $payroll)` in `KaryawanSlipGajiController.php` due to missing authorization checks on route model binding.
**Learning:** Endpoints generating downloadable files/PDFs are easily overlooked for authorization checks, as developers focus on the view/file generation logic, assuming the route ID is obfuscated or hidden. Obfuscation is not security.
**Prevention:** Consistently apply explicit ownership and status authorization checks against the authenticated user on all endpoints accepting direct object references, regardless of the output format.
