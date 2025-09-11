docker build -t apache-test . 
docker run -d --name apache-container -p 8080:80 apache-test
docker stop apache-container
docker rm apache-container