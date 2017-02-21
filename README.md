# awale-symfony

Experimental Awale bot on Slack

## Run Webserver

```
make run
```

Your web server is up and running at [http://localhost](http://localhost)

## Stop Webserver

```
make stop
```

## Expose Webserver

```
make expose
```

We use ngrok to expose web server, we can't call localhost directly for slack webhook.
Ngrok generate tunnel to localhost, looks like http://*****.ngrok.io

## Test

```
make test
```
