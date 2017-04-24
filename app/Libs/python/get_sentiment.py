import sys
from textblob_de import TextBlobDE as TextBlob

reload(sys)
sys.setdefaultencoding('utf8')

text = sys.argv[1]
blob = TextBlob(text)
print(blob.polarity)