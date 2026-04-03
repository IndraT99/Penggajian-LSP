## 2024-04-03 - Insecure Direct Object Reference (IDOR) in PDF Generation
**Vulnerability:** IDOR vulnerability in KaryawanSlipGajiController@generatePDF due to missing ownership checks after route model binding. An authenticated employee could download another employee's payslip PDF by accessing the route with a different payroll ID.
**Learning:** Route model binding does not imply authorization. Even if the route is protected by the `karyawan` role, we must still explicitly verify that the fetched resource belongs to the currently authenticated user.
**Prevention:** Always verify `$resource->owner_id === $currentUser->id` (or similar logic) in controller methods handling direct object references, or use Laravel's Policy authorization checks.
