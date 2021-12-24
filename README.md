# Network Manager
![Last commit](https://img.shields.io/github/last-commit/Sander0542/Network-Manager?style=for-the-badge)
![License](https://img.shields.io/github/license/Sander0542/Network-Manager?style=for-the-badge)

Simple web application that lets you manage the used hosts in your networks. It supports multiple networks based on their subnet and size. Within each host you can specify the ports that are used and the services that are running on them.

## Docker
![Docker Pulls](https://img.shields.io/docker/pulls/sander0542/network-manager?style=for-the-badge)
![Docker Stars](https://img.shields.io/docker/stars/sander0542/network-manager?style=for-the-badge)

### Usage

```shell
docker run -d \
  --name=network-manager \
  -e PUID=1000 \
  -e PGID=1000 \
  -e TZ=Europe/Amsterdam \
  -e APP_KEY= `#random string (length 32)` \
  -e DB_HOST=127.0.0.1 `#optional` \
  -e DB_PORT=3306 `#optional` \
  -e DB_USERNAME=root `#optional` \
  -e DB_PASSWORD= `#optional` \
  -e DB_DATABASE=network_manager `#optional` \
  -e OCTANE_HTTPS=false `#optional` \
  -p 9000:9000 \
  --restart unless-stopped \
  sander0542/network-manager
```

### Parameters
#### Ports
| Parameter | Function |
|-----------|----------|
| 9000      | Web GUI  |

#### Environment Variables

| Env          | Required | Default         | Function                                                                                                                      |
|--------------|----------|-----------------|-------------------------------------------------------------------------------------------------------------------------------|
| APP_KEY      | Yes      |                 | The key used to secure data. (random string of 32 characters [a-zA-Z0-9])                                                     |
| DB_HOST      | No       | 127.0.0.1       | Host of the MySQL server                                                                                                      |
| DB_PORT      | No       | 3306            | Port of the MySQL server                                                                                                    |
| DB_USERNAME  | No       | root            | Username of the MySQL server                                                                                                |
| DB_PASSWORD  | No       |                 | Password of the MySQL server                                                                                                |
| DB_DATABASE  | No       | network_manager | Database of the MySQL server                                                                                                |
| OCTANE_HTTPS | No       | false           | Whether the webserver should generate HTTPS links instead of HTTP links. (Set this to true when running behind a HTTPS proxy) |


## Contributors
![Network Manager Contributors](https://contrib.rocks/image?repo=Sander0542/Network-Manager)
