import sys
import gender_guesser.detector as gender
detector = gender.Detector(case_sensitive=False)
print(detector.get_gender(sys.argv[1]))