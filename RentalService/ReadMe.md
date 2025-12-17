# Projet Docker 

## Initialisation

 ### Création de l'espace d'environnement du projet

 Dans le terminal, tapez cette commande : 

```bash
    mkdir dockerProject && cd dockerProject
```

Par la suite, il sera nécessaire de clôner le projet Docker présent sur Github avec la commande suivante : 

```bash
    git clone https://github.com/charroux/ingnum
```

**Warning : Il sera nécessaire de changer la branche pour qu'on créer un répository propre à nous. Cela, permettra de faire des push sans modifier le repository du professeur** 

Ainsi, suivez les commandes suivantes : 

1. Créer votre propre repo sur Github 
2. En ligne de commande, tapez : 

```bash
    cd ingnum && cd RentalService
```

3. Appropriation du projet et l'affecter à son repo avec : 

```bash
    git remote remove origin
    git add remote origin (addresse de votre git)
```

## Réalisation du projet 

### I. Compilation du projet

En premier lieu, nous souhaitons tester le projet sans Docker pour voir s'il marche sur notre machine. Pour cela, toujours en ligne de commande dans le dossier RentalService, il sera nécessaire de compiler le projet avec : 

```bash
./gradlew build
java -jar build/libs/RentalService-0.0.1-SNAPSHOT.jar
```

Une fois le projet compiler, nous pourrons vérifier sur le navigateur si nous avons bel et bien accès au résultat *bonjour* sur la page HTML qui aura été général. 

Sur la barre de recherche, tapez la commande : 

```
http://localhost:8080/bonjour
```
### II. Initialisation de Docker

Une fois qu'on aura vérifier que le projet fonctionne bien, il sera nécessaire de retourner une nouvelle fois sur votre Terminal. 

1. Créer un fichier Dockerfile 

```bash
    touch Dockerfile
```

2. Mettez dans ce fichier les informations adéquates 

```bash
    vim Dockerfile
    :i

    FROM eclipse-temurin:21
    VOLUME /tmp
    EXPOSE 8080
    ADD ./build/libs/RentalService-0.0.1-SNAPSHOT.jar app.jar
    ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]

    :wq
```

3. Création de l'image docker : 

```bash
    docker build –t nomImageDpcker .
```

**WARNING : Ne faisez pas un copié-collé de la commande mais tapez la à la main pour que ça marche. Pour le nom de l'image, aucunes majuscule ne sera acceptées.**

4. Tester l'image 

```bash
    docker run –p 8080:8080 nomImageDocker
```

5. Vérifier l'URL 

```
http://localhost:8080/bonjour
```

6. Publication de l'image de Docker 
... (10lignes restantes)