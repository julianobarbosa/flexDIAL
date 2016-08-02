#!/bin/bash
cd /tmp
rm -rf flexDIAL
git clone https://github.com/julianobarbosa/flexDIAL.git
cd flexDIAL
/bin/cp vicidial_admin_web_logo_small.gif /srv/www/htdocs/agc/images/vdc_tab_vicidial.gif
/bin/cp vicidial_admin_web_logo_small.gif /srv/www/htdocs/agc/images/vtc_tab_vicidial.gif
/bin/cp vicidial_admin_web_logo_small.gif /srv/www/htdocs/agc/images/vdc_tab_vicidial_ptbr.gif
/bin/cp vicidial_admin_web_logo_branca.png /srv/www/htdocs/vicidial/vicidial_admin_web_logo.gif
/bin/cp vicidial_admin_web_logo_branca.png /srv/www/htdocs/agc/images/vicidial_admin_web_logo.png
/bin/cp vicidial_admin_web_logo_branca.png /srv/www/htdocs/vicidial/images/vicidial_admin_web_logoflexDIAL.png
/bin/cp vicidial_admin_web_logo_branca.png /srv/www/htdocs/vicidial/images/vicidial_admin_web_logo.png
/bin/cp vicidial_admin_web_logo_small_branca.png /srv/www/htdocs/vicidial/vicidial_admin_web_logo_small.gif
