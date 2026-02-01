# Deploy to Vercel

## Steps:
1. Go to https://vercel.com
2. Sign up/Login with GitHub
3. Click 'New Project'
4. Import your GitHub repo: jerylcapstone-pixel/Works
5. Configure:
   - Framework Preset: Other
   - Root Directory: /
   - Build Command: (leave empty)
   - Output Directory: (leave empty)
6. Add environment variables if needed (for production DB)
7. Click Deploy

## Your app will be live at: https://your-app-name.vercel.app

## Features:
- Automatic HTTPS
- Global CDN
- SQLite database (file-based, persists across deployments)
- PHP 8.1 runtime

## Local Development:
- MySQL for local dev
- SQLite for Vercel deployment
- Automatic table creation on Vercel
