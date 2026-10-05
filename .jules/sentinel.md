## 2023-10-05 - Missing Authentication on Utility/Setup Routes
**Vulnerability:** The `/setup-database` and `/fix-ssl` utility routes, which execute sensitive system commands like `Artisan::call('migrate --force')` and `Artisan::call('config:clear')`, were exposed publicly without any authentication or authorization middleware.
**Learning:** Even utility routes meant for initial deployment or troubleshooting must be secured. Exposing them allows unauthenticated attackers to manipulate the application state, clear caches, or potentially cause a Denial of Service (DoS).
**Prevention:** Always ensure utility or setup routes are placed within robust authentication and authorization middleware groups (e.g., `['auth', 'role:admin']`) to restrict access strictly to highly privileged users.
