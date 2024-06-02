# 开发环境
### 创建开发环境网络
    docker network create --driver bridge bileishe
### 运行后端服务
    docker run --name bileishe-hyperf-01 -v D:\Dev\gitee\deepwell\bileishe\server:/home/bileishe -p 59501:9501 -p 59502:9502 -p 59503:9503 -it --privileged -u root --entrypoint /bin/sh --net bileishe bileishe-hyperf-dev
### 运行redis
    docker run --name bileishe-redis-01 -p 56379:6379 --net bileishe redis
### 运行mysql
    docker run --name bileishe-mysql-01 -p 53306:3306 --net bileishe -e "MYSQL_ROOT_PASSWORD=s1mPl3R4nd0mP456w0rd" mysql