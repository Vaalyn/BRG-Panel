FROM composer:2.10

# vendor/ is bind-mounted from the host, so source-installed packages are git repos owned by another user
RUN git config --system --add safe.directory '*'
