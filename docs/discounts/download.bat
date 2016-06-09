: c:\Progra~1\GnuWin32\bin\wget -o log http://www.maxima.ee/pakkumised
: c:\Progra~1\GnuWin32\bin\wget -o log -r -l 1 -A jpg http://www.maxima.ee/pakkumised

c:\Progra~1\GnuWin32\bin\wget -E -H -k -K -p -A jpg, html http://www.maxima.ee/pakkumised -o maxima_log
: c:\Progra~1\GnuWin32\bin\wget -E -H -k -K -p https://www.coop.ee/uued-tooted/ -o coop_log --no-check-certificate
: c:\Progra~1\GnuWin32\bin\wget -E -H -k -K -p -A jpg, html https://www.selver.ee/soodushinnaga-tooted --no-check-certificate -o selver_log 
: c:\Progra~1\GnuWin32\bin\wget -E -H -k -K -p -A jpg, html https://www.prismamarket.ee/products/offers --no-check-certificate -o prisma_log