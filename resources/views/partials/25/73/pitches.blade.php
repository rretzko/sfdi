<style>
    .pitches {list-style-type: none; max-width: 500px; }
    .pitches li{font-size: 1rem; font-weight: bold; background-color: #e2e8f0; padding-left: .5rem; padding-right: .5rem; margin-bottom:.25rem;}
    .pitches li ul{list-style-type: none; background-color: white;}
    .pitches li ul li{font-size: .8rem; background-color: white;}
    .pitches li ul li ul li{font-weight: normal; display: flex;}
    .pitches li ul li ul li label{padding-top: 1rem;margin-right: 1rem; min-width: 44%; text-align: right;}
    .pitches li ul li ul li audio{min-width: 54%;}
</style>
<ul class="pitches">
    @if(auth()->user()->person->student->gradeClassOf < 9)
        <li style="font-size: larger; text-transform: uppercase;">Middle School
            <ul>
                <li style="padding: 0.5rem;">
                    Solo
                    <a href="/assets/pitchfiles/25/73/pdfs/velvet_shoes.pdf" target="_NEW" style="font-size: larger;">
                        Velvet Shoes PDF
                    </a>
                </li>

                <li>Soprano
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/s/s-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/s/s-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/s/s-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/s/s-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Velvet Shoes</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/s/s-solo-velvet-shoes.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/s/s-solo-velvet-shoes.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Soprano -->

                <li>Alto
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/a/a-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/a/a-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/a/a-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/a/a-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Velvet Shoes</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/a/a-solo-velvet-shoes.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/a/a-solo-velvet-shoes.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Alto -->

                <li>High Baritone
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/hb/hb-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/hb/hb-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/hb/hb-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/hb/hb-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Velvet Shoes</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/hb/hb-solo-velvet-shoes.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/hb/hb-solo-velvet-shoes.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of High Baritone -->

                <li>Low Baritone
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/lb/lb-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/lb/lb-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/lb/lb-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/lb/lb-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Velvet Shoes</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/lb/lb-solo-velvet-shoes.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/lb/lb-solo-velvet-shoes.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Low Baritone -->

            </ul>
        </li><!-- end of Middle School -->
    @else
        <li style="font-size: larger; text-transform: uppercase;">High School
            <ul>

                <li style="padding: 0.5rem;">
                    Solo
                    <a href="/assets/pitchfiles/25/73/pdfs/ash_grove.pdf" target="_NEW" style="font-size: larger;">
                        Ash Grove PDF
                    </a>
                </li>

                <li>Soprano I
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/si/s_i-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/si/s_i-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/si/s_i-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/si/s_i-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/si/s_i-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/si/s_i-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Soprano I -->

                <li>Soprano II
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/sii/s_ii-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/sii/s_ii-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/sii/s_ii-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/sii/s_ii-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/sii/s_ii-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/sii/s_ii-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Soprano II -->

                <li>Alto I
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ai/a_i-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ai/a_i-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ai/a_i-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ai/a_i-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/ai/a_i-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/ai/a_i-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Alto I -->

                <li>Alto II
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/aii/a_ii-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/aii/a_ii-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/aii/a_ii-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/aii/a_ii-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/aii/a_ii-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/aii/a_ii-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Alto II -->

                <li>Tenor I
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ti/t_i-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ti/t_i-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ti/t_i-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/ti/t_i-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/ti/t_i-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/ti/t_i-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Tenor I -->

                <li>Tenor II
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/tii/t_ii-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/tii/t_ii-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/tii/t_ii-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/tii/t_ii-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/tii/t_ii-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/tii/t_ii-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Tenor II -->

                <li>Bass I
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bi/b_i-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bi/b_i-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bi/b_i-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bi/b_i-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/bi/b_i-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/bi/b_i-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Bass I -->

                <li>Bass II
                    <ul>
                        <li>Scales
                            <ul style="margin-left:-10rem;">
                                <li>
                                    <label>High Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bii/b_ii-scales-high-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bii/b_ii-scales-high-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                                <li>
                                    <label>Low Scale</label>
                                    <audio controls>
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bii/b_ii-scales-low-scale.mp3"
                                            type="audio/mpeg">
                                        <source
                                            src="https://studentfolder.info/assets/pitchfiles/25/73/scales/bii/b_ii-scales-low-scale.mp3"
                                            type="audio/ogg">
                                    </audio>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>Solo: Ash Grove</label>
                            <audio controls>
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/bii/b_ii-solo-ash-grove.mp3"
                                    type="audio/mpeg">
                                <source
                                    src="https://studentfolder.info/assets/pitchfiles/25/73/solos/bii/b_ii-solo-ash-grove.mp3"
                                    type="audio/ogg">
                            </audio>
                        </li>
                    </ul>
                </li><!-- end of Bass II -->

            </ul>
        </li><!-- end of High School -->
    @endif

</ul><!-- end of pitches -->
