import { defineConfig, devices } from "@playwright/test";
const baseUri = process.env.MONGODB_URI || "mongodb://127.0.0.1:27017";
const testDbName = process.env.TEST_MONGODB_DB || `oopsskin_test_${Date.now()}`;
const mongoUri = `${baseUri.replace(/\/[^/?]*(\?.*)?$/, "")}/${testDbName}${baseUri.includes("?") ? baseUri.slice(baseUri.indexOf("?")) : ""}`;
process.env.TEST_MONGODB_URI = mongoUri;
export default defineConfig({
  testDir: "./tests", fullyParallel: false, workers: 1, timeout: 30000,
  use: { baseURL: "http://localhost:3107", trace: "retain-on-failure", launchOptions: { executablePath: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH } },
  projects: [{ name: "chromium", use: { ...devices["Desktop Chrome"] } }],
  webServer: { command: "npm run start -- --port 3107", url: "http://localhost:3107", reuseExistingServer: false, timeout: 60000, env: { MONGODB_URI: mongoUri, APP_ORIGIN: "http://localhost:3107" } },
});
