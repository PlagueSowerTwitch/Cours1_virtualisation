# 📘 Kubernetes TP – Rapport de Commandes & Preuves Visuelles
Bonjour, ceci est le mini rapport écrit étape par étape pour le TP3 de Frédérick Rat, chaque étape est tiré du TP suivant : https://github.com/charroux/kubernetes-minikube?tab=readme-ov-file#create-a-kubernetes-deployment-from-a-docker-image
---

## 1️⃣ **Initialisation et vérification du cluster**
**Commande**
```bash
kubectl get nodes
```
**Objectif**
Vérifier que le cluster Kubernetes (Minikube) est opérationnel.
**Pourquoi ?**
Cette commande permet de lister tous les nœuds du cluster et leur statut. Elle confirme que Minikube est bien démarré et prêt à recevoir des déploiements.

**Screenshot à fournir 📸**
- Terminal affichant le nœud `minikube` avec le statut **Ready**

---

## 2️⃣ **Création du Deployment à partir d’une image Docker**
**Commande**
```bash
kubectl create deployment myservice --image=ratatouillerat/rentalservice
```
**Objectif**
Créer un Deployment Kubernetes qui gère l’exécution de l’application dans un Pod.
**Pourquoi ?**
Un Deployment permet de déclarer l’état souhaité de l’application (image, nombre de réplicas, etc.) et Kubernetes s’occupe de maintenir cet état, même en cas de panne.

**Screenshots à fournir 📸**
- Terminal montrant la création du deployment
- Résultat de `kubectl get deployments`

---

## 3️⃣ **Vérification du Pod**
**Commandes**
```bash
kubectl get pods
kubectl describe pod myservice-XXXXX
```
**Objectif**
Vérifier que le Pod est bien créé et en état **Running**.
**Pourquoi ?**
Un Pod est l’unité de base d’exécution dans Kubernetes. Vérifier son état permet de s’assurer que l’application est bien en cours d’exécution et qu’il n’y a pas d’erreur de démarrage.

**Screenshots à fournir 📸**
- Liste des Pods avec statut **Running**
- Extrait de `kubectl describe pod` montrant :
  - Image utilisée
  - État **Running**

---

## 4️⃣ **Logs de l’application**
**Commande**
```bash
kubectl logs myservice-XXXXX
```
**Objectif**
Vérifier que l’application démarre correctement dans le container.
**Pourquoi ?**
Les logs permettent de diagnostiquer les problèmes de démarrage ou de fonctionnement de l’application, et de confirmer que le service est prêt à recevoir des requêtes.

**Screenshot à fournir 📸**
- Logs Spring Boot montrant :
  - `Tomcat started on port 8080`

---

## 5️⃣ **Exposition du Deployment avec un Service NodePort**
**Commandes**
```bash
kubectl expose deployment myservice --type=NodePort --port=8080 --target-port=8080
kubectl get services
minikube service myservice --url
```
**Objectif**
Rendre l’application accessible depuis l’extérieur du cluster.
**Pourquoi ?**
Un Service de type NodePort expose le Pod sur un port statique du nœud, permettant d’accéder à l’application depuis un navigateur ou un outil externe.

**Screenshots à fournir 📸**
- Résultat de `kubectl get services` montrant :
  - Type **NodePort**
  - Port exposé
- Navigateur affichant la page de l’application (`/hello`)

---

## 6️⃣ **Dashboard Minikube**
**Commande**
```bash
minikube dashboard
```
**Objectif**
Visualiser graphiquement les ressources Kubernetes.
**Pourquoi ?**
Le dashboard offre une vue d’ensemble des déploiements, pods, services et autres ressources, ce qui facilite le monitoring et le débogage.

**Screenshots à fournir 📸**
- Vue **Deployments**
- Vue **Pods**
- Vue **Services** avec NodePort

---

## 7️⃣ **Accès interactif au container**
**Commandes**
```bash
kubectl exec -it myservice-XXXXX -- /bin/bash
ls
exit
```
**Objectif**
Montrer que le container tourne bien à l’intérieur du Pod.
**Pourquoi ?**
Accéder au shell du container permet de vérifier l’environnement, les fichiers présents, et d’effectuer des diagnostics ou des tests manuels.

**Screenshot à fournir 📸**
- Terminal dans le container avec la commande `ls`

---

## 8️⃣ **Scaling horizontal du Deployment**
**Commandes**
```bash
kubectl scale --replicas=2 deployment/myservice
kubectl get deployments
kubectl get pods
```
**Objectif**
Démontrer la montée en charge horizontale (scaling).
**Pourquoi ?**
Augmenter le nombre de réplicas permet de répartir la charge entre plusieurs Pods, améliorant la disponibilité et la performance de l’application.

**Screenshots à fournir 📸**
- Résultat de `kubectl get deployments` montrant **2/2**
- Résultat de `kubectl get pods` avec **2 Pods Running**

---

## 9️⃣ **Load balancing via le Service**
**Commandes**
```bash
kubectl logs -f -l app=myservice
curl http://127.0.0.1\:XXXXX/hello
```
**Objectif**
Montrer la répartition des requêtes entre plusieurs Pods.
**Pourquoi ?**
Le Service agit comme un load balancer, répartissant les requêtes entre les différents Pods disponibles, ce qui optimise l’utilisation des ressources et la résilience.

**Screenshots à fournir 📸**
- Logs montrant plusieurs requêtes
- Dashboard → Service → Endpoints (2 IPs)

---

## 🔟 **Création d’un Service de type LoadBalancer**
**Commandes**
```bash
kubectl delete service myservice
kubectl expose deployment myservice --type=LoadBalancer --port=8080
kubectl get services
minikube service myservice --url
```
**Objectif**
Exposer l’application via un LoadBalancer (simulé par Minikube).
**Pourquoi ?**
Un LoadBalancer permet une exposition plus flexible et scalable de l’application, notamment dans un environnement cloud.

**Screenshots à fournir 📸**
- Résultat de `kubectl get services` montrant Type **LoadBalancer**
- Navigateur avec l’application accessible

---

## 1️⃣1️⃣ **Rolling Update (mise à jour sans interruption)**
**Commandes**
```bash
kubectl set image deployment/myservice rentalservice=ratatouillerat/rentalservice\:v2
kubectl rollout status deployment/myservice
kubectl get pods
```
**Objectif**
Mettre à jour l’application sans downtime.
**Pourquoi ?**
Un rolling update permet de déployer une nouvelle version de l’application progressivement, sans interruption de service, en remplaçant les Pods un par un.

**Screenshots à fournir 📸**
- Pods anciens + nouveaux pendant la mise à jour
- Message : **successfully rolled out**

---

## 1️⃣2️⃣ **Rollback (retour à la version précédente)**
**Commandes**
```bash
kubectl rollout history deployment/myservice
kubectl rollout undo deployment/myservice
```
**Objectif**
Montrer la capacité de retour arrière en cas de problème.
**Pourquoi ?**
En cas d’erreur ou de régression, le rollback permet de revenir rapidement à une version stable de l’application, garantissant la continuité du service.

**Screenshot à fournir 📸**
- Historique des révisions

---
## 1️⃣3️⃣ **Création de fichiers YAML pour les Deployments et Services**

**Fichier créé : `kubernetes.yml`**

Remplacement des commandes kubectl par des fichiers YAML déclaratifs :

```yaml
---
# Déploiement du RentalService (Frontend)
apiVersion: apps/v1
kind: Deployment
metadata:
  name: rental-service-deployment
  labels:
    app: rental-service
spec:
  replicas: 1
  selector:
    matchLabels:
      app: rental-service
  template:
    metadata:
      labels:
        app: rental-service
    spec:
      containers:
        - name: rental-service-container
          image: rental-service:latest
          imagePullPolicy: Never
          ports:
            - containerPort: 8080
      restartPolicy: Always
---
# Service pour RentalService (NodePort)
apiVersion: v1
kind: Service
metadata:
  name: rental-service
spec:
  type: NodePort
  selector:
    app: rental-service
  ports:
    - port: 8080
      targetPort: 8080
      nodePort: 30080
---
# Déploiement du SurnameService (Backend)
apiVersion: apps/v1
kind: Deployment
metadata:
  name: surname-service-deployment
spec:
  replicas: 1
  selector:
    matchLabels:
      app: surname-service
  template:
    metadata:
      labels:
        app: surname-service
    spec:
      containers:
        - name: surname-service-container
          image: surname-service:latest
          imagePullPolicy: Never
          ports:
            - containerPort: 80
---
# Service pour SurnameService (ClusterIP)
apiVersion: v1
kind: Service
metadata:
  name: surname-service
spec:
  type: ClusterIP
  selector:
    app: surname-service
  ports:
    - port: 80
      targetPort: 80
```

**Objectif**
Utiliser l'Infrastructure as Code (IaC) pour déclarer les ressources Kubernetes.

**Commande**
```bash
kubectl apply -f kubernetes.yml
```

---

## 1️⃣4️⃣ **Communication entre microservices**

**Fichier modifié : `application.properties`**

```properties
server.port=8080
spring.application.name=RentalService

# Docker Compose configuration
# surname.service.url=http://surname-service

# Kubernetes configuration
surname.service.url=http://surname-service.default.svc.cluster.local:80
```

**Objectif**
Configurer les URL selon l'environnement (Docker Compose vs Kubernetes).

**Points clés**
- RentalService (frontend) accède à SurnameService (backend) via DNS Kubernetes
- Format : `<service-name>.<namespace>.svc.cluster.local`
- Le Service agit comme load balancer interne

---

## 1️⃣5️⃣ **Gateway - Ingress (Routage NGINX)**

**Activation du contrôleur NGINX**
```bash
minikube addons enable ingress
```

**Fichier créé : `ingress.yml`**

```yaml
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: rental-ingress
spec:
  ingressClassName: nginx
  rules:
    - host: rental-service.local
      http:
        paths:
          - path: /
            pathType: Prefix
            backend:
              service:
                name: rental-service
                port:
                  number: 8080
    - host: surname-service.local
      http:
        paths:
          - path: /
            pathType: Prefix
            backend:
              service:
                name: surname-service
                port:
                  number: 80
```

**Objectif**
Créer un point d'entrée unique (porte d'entrée) pour tous les microservices.

**Avantages de l'Ingress**
- ✅ Point d'entrée unique
- ✅ Routage intelligent par hostname/chemin
- ✅ Économie de ressources (moins de LoadBalancer)
- ✅ Gestion centralisée SSL/TLS

**Configuration du fichier hosts (Windows)**
```
127.0.0.1 rental-service.local
127.0.0.1 surname-service.local
```

**Activation du tunnel Minikube**
```bash
minikube tunnel
```

**Commande d'application**
```bash
kubectl apply -f ingress.yml
kubectl get ingress
```

**Accès**
- http://rental-service.local/ → RentalService
- http://surname-service.local/ → SurnameService

---

## 📝 **Résumé des changements**

| Fichier | Changement | Raison |
|---------|-----------|--------|
| `kubernetes.yml` | **Créé** | Déploiements et Services |
| `application.properties` | **Modifié** | URL Kubernetes pour inter-services |
| `ingress.yml` | **Créé** | Routage NGINX |
| `Dockerfile` (SurnameService) | **Corrigé** | Problème d'encodage |

---

## 🎯 **Architecture finale**

```
Internet
    ↓
Ingress NGINX (porte d'entrée unique - 192.168.49.2)
    ├─ rental-service.local → RentalService (NodePort:30080)
    │                           ↓ Pod:8080
    │
    └─ surname-service.local → SurnameService (ClusterIP:80)
                                 ↓ Pod:80
```

**Communication inter-services**
- RentalService → SurnameService : `http://surname-service.default.svc.cluster.local:80`

---

## ✅ **Vérification finale**

```bash
kubectl get deployments
kubectl get services
kubectl get ingress
kubectl get pods
```

**Ressources déployées**
- ✅ 2 Deployments
- ✅ 2 Services (1 NodePort + 1 ClusterIP)
- ✅ 1 Ingress avec 2 routes
- ✅ Communication inter-pods via DNS Kubernetes
"@; Set-Content "TP3.md" $newContent