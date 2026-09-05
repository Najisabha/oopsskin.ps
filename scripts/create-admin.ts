import { randomUUID } from "node:crypto";
import { createInterface } from "node:readline/promises";
import { stdin, stdout } from "node:process";
import { db } from "../src/lib/db";
import { hashPassword } from "../src/lib/auth";
import { registerSchema } from "../src/lib/validation";
import type { User } from "../src/lib/types";

// Password can be supplied through ADMIN_PASSWORD without appearing in arguments/history.
async function main() {
const readline = createInterface({ input: stdin, output: stdout });
try {
  const email = process.env.ADMIN_EMAIL || await readline.question("Admin email: ");
  const name = process.env.ADMIN_NAME || await readline.question("Admin name: ");
  let password = process.env.ADMIN_PASSWORD;
  if (!password) {
    if (!stdin.isTTY) throw new Error("Set ADMIN_PASSWORD when running non-interactively.");
    stdout.write("Admin password (hidden): ");
    readline.close();
    password = await new Promise<string>((resolve,reject) => {
      let value = "";
      stdin.setRawMode(true); stdin.resume();
      const finish = () => { stdin.setRawMode(false); stdin.removeListener("data",onData); stdin.pause(); stdout.write("\n"); };
      const onData = (chunk: Buffer) => { for (const char of chunk.toString()) { if (char === "\u0003") { finish(); reject(new Error("Cancelled")); return; } if (char === "\r" || char === "\n") { finish(); resolve(value); return; } if (char === "\u007f") value = value.slice(0,-1); else value += char; } };
      stdin.on("data",onData);
    });
  }
  const input = registerSchema.parse({ email: email.trim(), name, password });
  const existing = db().prepare("SELECT id,data FROM users WHERE email=?").get(input.email);
  if (existing) throw new Error("This email already exists. Use a new admin email; existing users are not silently promoted.");
  const user: User = { id: randomUUID(), name: input.name, email: input.email, phone: "", address: "", city: "", role: "admin" };
  db().prepare("INSERT INTO users VALUES (?,?,?,?)").run(user.id,user.email,hashPassword(input.password),JSON.stringify(user));
  console.log(`Admin account created for ${user.email}. Sign in at /login.`);
} catch(e) { console.error(e instanceof Error ? e.message : e); process.exitCode=1; } finally { readline.close(); }

}
void main();
