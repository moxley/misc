install:
	if [ ! -f lib/config.ini ]; then \
		cp lib/config-sample.ini lib/config.ini; \
	fi; \
	if [ ! -f lib/data.ser ]; then \
		touch lib/data.ser; \
		php -r 'include "lib/boot.php"; include "test.inc.php"; test_reset_data();'; \
	fi; \
	chmod 666 lib/data.ser

clean:
	rm lib/data.ser lib/config.ini
