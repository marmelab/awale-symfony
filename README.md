<table>
        <tr>
            <td><img width="120" src="https://cdnjs.cloudflare.com/ajax/libs/octicons/8.5.0/svg/rocket.svg" alt="onboarding" /></td>
            <td><strong>Archived Repository</strong><br />
            The code of this repository was written during a <a href="https://marmelab.com/blog/2018/09/05/agile-integration.html">Marmelab agile integration</a>. <a href="https://marmelab.com/blog/2017/03/15/awale-slack.html">The associated blog post</a> illustrates the efforts of the new hiree, who had to implement a board game in several languages and platforms as part of his initial learning.<br />
        <strong>This code is not intended to be used in production, and is not maintained.</strong>
        </td>
        </tr>
</table>

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
