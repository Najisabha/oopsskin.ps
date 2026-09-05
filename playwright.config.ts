import { defineConfig, devices } from "@playwright/test";
import path from "node:path";
import os from "node:os";
const databasePath = process.env.TEST_DATABASE_PATH || path.join(os.tmpdir(), `oopsskin-test-${Date.now()}.sqlite`);
process.env.TEST_DATABASE_PATH = databasePath;
export default defineConfig({
  testDir: "./tests", fullyParallel: false, workers: 1, timeout: 30000,
  use: { baseURL: "http://localhost:3107", trace: "retain-on-failure", launchOptions: { executablePath: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH } },
  projects: [{ name: "chromium", use: { ...devices["Desktop Chrome"] } }],
  webServer: { command: "npm run start -- --port 3107", url: "http://localhost:3107", reuseExistingServer: false, timeout: 60000, env: { DATABASE_PATH: databasePath, APP_ORIGIN: "http://localhost:3107" } },
});
