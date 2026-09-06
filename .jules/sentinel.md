## 2024-05-18 - Missing IDOR Check in PDF Generation Endpoint

**Vulnerability:**
The `KaryawanSlipGajiController@generatePDF` endpoint failed to check if the generated `Payroll` object belonged to the authenticated `Employee` making the request. Even though it used Route Model Binding, this did not restrict access based on ownership, allowing anyone with the ID to access other users' payroll PDFs (an Insecure Direct Object Reference - IDOR vulnerability). Also, it did not check for `approved_finance` or `paid` state before serving the file.

**Learning:**
Developers tend to overlook authorization checks on endpoints returning direct file streams (like PDF generation views) since they are focused on the formatting logic rather than the core CRUD flow. Route obfuscation (`HashService`/`HashIdRoute`) obfuscates the ID but is not a substitute for true access control checks against the user.

**Prevention:**
Always invoke `$this->getAuthenticatedEmployee()` (or equivalent authorization logic) on ALL controller methods—including custom view/PDF generating routes—and compare the target object's `employee_id` with the authenticated `Employee->id` before loading the view or file. Also, enforce final state checks (like `status`) before exposing generated reports.
