# IRO Mission Control - Architecture & State Document

**Date:** April 2026
**Environment:** Active Sync (Local OpenClaw Host proxying to `bullmight.com`)
**Core File:** `bullmight-main-site/page-iro-console.php`

## 1. LocalTunnel Routing Matrix
The console relies on a multi-port split-tunnel architecture to bypass remote-to-local origin restrictions, ensuring continuous high-bandwidth telemetry from the N8N workflows.

- **Port 3005:** `iro-bullmight-lesson15.loca.lt`
  - *Function:* Lesson plan ingestion and status telemetry.
- **Port 3006:** `iro-bullmight-bridge14.loca.lt`
  - *Function:* Live Chat Terminal (OpenClaw Gateway). Standard interactions (`?iro_proxy=chat`).
- **Port 3007:** `iro-bullmight-action16.loca.lt`
  - *Function:* Dedicated SEO payload action node. Handles high-intensity Web SEO (DataForSEO) and LocalFalcon API injection workflows (`?iro_proxy=action`).

## 2. Core UI Modules

### 2.1 The Dashboard
- **Agents Panel:** Displays status of running sub-agents (IRO, MASTERCHEF, VOLT [WhatsApp], PICASSO).
- **Vault Server:** Secure local iFrame previews and direct downloads of N8N-generated `.pdf` pipelines and lesson plans.
- **Health Dashboard:** Dynamic WMI ingestion plotting CPU, RAM, and internal/external dual-disk storage allocations.

### 2.2 SEO Command Center (Dual-Pane)
Rebuilt to decouple Map rankings from broad organic telemetry.
- **DataForSEO (Web API):** Interrogates standard `text-based` SERP metrics based on specified keywords.
- **LocalFalcon (Maps API):** Consumes LF Credits to generate a precise 5-mile block-by-block GMB grid overlay directly onto the React dashboard.
- *Triggers:* On execution, the map URL is pushed across `Port 3007`, routing directly to the N8N engine, which then injects the response array sequentially back into the Chat Terminal under the name `MASTERCHEF`.

### 2.3 The Bridge: Action Required
- A continuous-polling widget monitoring Antigravity's pending actions (WP Pusher operations, workflow deployments) to prevent unapproved remote sandbox breaches.

## 3. Pending Feature Integrations (Test Mode)
- **Multimedia Chat Injection:** The system is currently being explicitly tested for autonomous Chat Uploading/Screenshot transmission capabilities. The infrastructure is listening to see if the local AI payload can push `multipart/form-data` properly back through the native chat array to the host UI.
