"""
From the Terminal, run:

python analysis.py results_directory/

where "results_directory/" is a directory full of the raw data files.
The script will produce three PDFs of results.
"""

import os
from sys import argv
import numpy as np
import matplotlib.pyplot as plt

colors = {'blue': '#03A7FF', 'pink': '#EC3D91'}

def main(directory, color='blue'):
  color = colors[color]
  IDs = os.listdir(directory)

  responses = np.array([0, 0, 0, 0, 0, 0, 0, 0, 0], dtype=float)
  reactions = np.array([0, 0, 0, 0, 0, 0, 0, 0, 0], dtype=float)
  scores = np.array([0, 0, 0, 0, 0, 0, 0, 0, 0], dtype=float)
  totals = np.array([0, 0, 0, 0, 0, 0, 0, 0, 0], dtype=float)

  for ID in IDs:
    if ID == '.DS_Store' or ID == 'log': continue
    f = open(directory + ID)
    data = f.read(); f.close()
    data = data.split('\n')
    for i in range(1, 46):
      target, response, reaction = data[i].split('\t')
      responses[int(target)-1] += float(response)
      reactions[int(target)-1] += float(reaction)
      if target == response: scores[int(target)-1] += 1.
      totals[int(target)-1] += 1.
  responses /= totals
  reactions /= totals
  scores /= totals; scores *= 100; scores = 100 - scores

  fig = plt.figure(figsize=(6,4))

  plt.plot(range(1, 10), reactions, c=color, markeredgecolor=color, marker='o', linewidth=3, markersize=8)
  plt.ylabel('Response time (milliseconds)')
  plt.xlim(0.8, 9.2)
  plt.ylim(500, 2500)
  plt.savefig('response_time.pdf')
  plt.clf()

  plt.plot(range(1, 10), scores, c=color, markeredgecolor=color, marker='o', linewidth=3, markersize=8)
  plt.ylabel('Error (%)')
  plt.xlim(0.8, 9.2)
  plt.ylim(0, 100)
  plt.savefig('error.pdf')
  plt.clf()

  plt.plot(range(1, 10), range(1,10), '--', c='black')
  plt.plot(range(1, 10), responses, c=color, markeredgecolor=color, marker='o', linewidth=3, markersize=8)
  plt.ylabel('Mean response number')
  plt.xlim(0.8, 9.2)
  plt.ylim(0.8, 9.2)
  plt.savefig('target_responce.pdf')
  plt.clf()

if __name__ == '__main__':
  if len(argv) == 1:
    print "Error: Please pass a directory of data files"
  elif len(argv) == 2:
    main(argv[1])
  elif len(argv) == 3:
    main(argv[1], argv[2])
  else:
    print "Too many arguments"
