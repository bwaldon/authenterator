SETTING UP RECAPTCHA WITH SUBMITERATOR

Brandon Waldon (bwaldon@stanford.edu - 8/29/2018)

- Step 1: get reCAPTCHA access through Google 

Set up your reCAPTCHA account (https://www.google.com/recaptcha/), then, from your main reCAPTCHA account page, find "Register a new site". Enter any 'Label' you'd like (I called mine "MTurk Authentication"), then select "reCAPTCHA v2" under 'Choose the type of reCAPTCHA'. To enable reCAPTCHA on all of your experiments served by Github Pages, enter your root github.io URL under 'Domains' (e.g. bwaldon.github.io).

When you complete the above steps, Google will provide you with two 'keys', a Site key and a Secret key. Hold on to these! 

Should you lose the keys, they're always accessible from your main reCAPTCHA account page. Under 'Your reCAPTCHA sites', click the site you created above, then directly under where it says 'Adding reCAPTCHA to your site' you'll see a collapsed tab called 'Keys'.

- Step 2: upload the 'verify.php' file to an appropriate server

(Be sure to first open this file in an editor and change the required fields. Lines 2 and 3 need to be changed.)

When users click the "Begin HIT" button, their reCAPTCHA result is validated through Google using the file ‘verify.php’. Unfortunately, GitHub Pages is (as of writing this readme, i.e. 8/2018) unable to handle PHP. So you need to upload ‘verify.php’ to a place that can handle PHP. 

One free option for Stanford affiliates is to use the Andrew File System (AFS). See here about how to request AFS services at Stanford: https://uit.stanford.edu/service/afs 

Should you choose to use AFS, you'll also need to enable the Stanford Common Gateway Interface (CGI) service. More on enabling CGI here: https://uit.stanford.edu/service/cgi

The eventual landing site of your PHP script should be somewhere within your cgi-bin folder on AFS, e.g. https://stanford.edu/~bwaldon/cgi-bin/verify.php

- Step 3: paste the HTML code into the index.html file of your experiment

As with the 'verify.php' file, change the required fields in an editor first. Lines 9 and 36 need to be changed. The code can, in principle, go in any unembedded position in your index.html file. 

- Step 4: paste the javascript code into the index.js file of your experiment

Nothing about this code needs to be changed. Just make sure that it's located where your other slides data are located (most likely embedded under 'function make_slides(f)...')

- Step 5: change the 'exp.structure' variable in index.js 

Add "captcha" as the first element of this array. Now, users can only go on to other parts of your experiment once Google has validated their reCAPTCHA data. That is, anyone who fails the reCAPTCHA is barred from participating in your experiment in the first place. Pretty neat! Hopefully less money wasted on useless bot data.
 
ERRATA:

Analytics and response storage: Google's Analytics service for reCAPTCHA is pretty suboptimal. To address this, the verify.php file is currently set up to save data about reCAPTCHA attempts (both successful and unsuccessful) as a list of JSON objects stored in a .txt file on your server. I think this is useful to see the nature of denials made to Workers on Turk (e.g. Did they try to go on without submitting the reCAPTCHA at all? Did they actually fail the reCAPTCHA?). But again, only people who successfully pass the reCAPTCHA in the first place are able to participate in your experiment. 

