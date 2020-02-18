import webbrowser
import os
import glob
import time

# globals
ROOTDIR = os.getcwd()
CONTAINER = ROOTDIR + '/sysgens/'
CRED_BRKDWN = CONTAINER + 'CredBreakdownRpt.html'
COL_RPT = CONTAINER + 'cumColRpt.html'
PSU_CLSLST = CONTAINER + 'PSUClasses.html'
PSUINFO = CONTAINER + 'PSUInfo.html'
VS_CLSLST = CONTAINER + 'VSClasses.html'
VSINFO = CONTAINER + 'VSInfo.html'
URL_HEADER = 'file://'


# clears the directory of all files with the .html extension
def cleardirectory():
    deletionidentifier = CONTAINER + "/*.html"
    files = glob.glob(deletionidentifier)
    for f in files:
        os.remove(f)

    exit(0)


# opens all the pages that the PHP script wrote
def process():
    # opens the page using parameters to reduce lines
    def open_page(file):
        webbrowser.open_new_tab(URL_HEADER + file)
    open_page(CRED_BRKDWN)
    open_page(COL_RPT)
    open_page(VSINFO)
    open_page(VS_CLSLST)
    open_page(PSUINFO)
    open_page(PSU_CLSLST)
    # give the system time to open all the specified files before deletion
    time.sleep(3)
    cleardirectory()


if __name__ == '__main__':
    # give the files time to register in the directory
    process()
