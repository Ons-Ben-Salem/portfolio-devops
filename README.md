<h1 align="center">🌐 Personal Portfolio – Dockerized + CI/CD Pipeline</h1>

<p align="center">
  Un portfolio professionnel développé en <strong>PHP</strong>, entièrement containerisé avec <strong>Docker</strong> et automatisé via <strong>GitHub Actions CI/CD</strong>.
</p>

<p align="center">
  🚀 DevOps • 🐳 Docker • 🔄 CI/CD • 🌩️ Cloud Ready
</p>

---

## ✨ Aperçu du projet

Ce projet représente mon portfolio personnel, conçu pour présenter mes réalisations, mes compétences et mes expériences.  
Il a été modernisé pour démontrer ma maîtrise des pratiques **DevOps**, notamment :

- Dockerization 🐳  
- Pipeline CI/CD automatisé 🔄  
- Structure professionnelle prête pour le déploiement 🌩️  

---

## 🐳 Dockerization

Le site est exécuté dans un container basé sur l'image officielle **php:8.2-apache**.

### ▶️ Lancer l'application avec Docker

```bash
docker build -t portfolio .
docker run -p 8080:80 portfolio

