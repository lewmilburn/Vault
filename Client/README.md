# Vault Client
The Vault client is an offline-capable version of Vault you can run on your local machine.

## System Requirements
### Development
- Node 20.11.1
- NPM 10.2.4

## Libraries Used
- TailwindCSS
- Electron

## Sync to Server
You require the Vault Webserver to be running to sync your passwords. For more information see the Web folder in the Vault repository. 

## Running & Building the app
### Running locally
`npm start`

### Building

| Platform | Architecture | Command                     |
|----------|--------------|-----------------------------|
| Windows  | Intel 64-bit | `npm run build:win:intel64` |
| Windows  | Intel 32-bit | `npm run build:win:intel32` |
| Windows  | ARM 64-bit   | `npm run build:win:arm64`   |
| Windows  | ARM 32-bit   | `npm run build:win:arm32`   |
| Windows  | Universal    | `npm run build:win`         |
| macOS    | Universal    | `npm run build:mac`         |
| Linux    | Universal    | `npm run build:linux`       |
