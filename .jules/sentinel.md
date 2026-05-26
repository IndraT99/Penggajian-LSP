## 2024-06-03 - Insecure Direct Object Reference in PDF Generation
**Vulnerability:** IDOR vulnerability found in `generatePDF` method where a Karyawan could view the slip gaji PDF for any other employee by passing their ID.
**Learning:** Endpoints that generate downloadable content (like PDFs) or file responses often get overlooked for standard access control checks compared to typical view-returning endpoints.
**Prevention:** Always ensure explicit authorization checks (e.g. verifying ownership by matching `$employee_id`) are applied uniformly across all endpoints, including those that stream files or export data. Check model binding state and apply identical checks as the corresponding `.show` endpoint.
