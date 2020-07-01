using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using Microsoft.VisualBasic;

namespace GatoRPCEncode
{
    public partial class Gato : Form
    {
        private ECCI.ECCI_B77519_B72097_GatoPortClient gato;
        private Stopwatch cronometro;

        public Gato()
        {
            InitializeComponent();
            gato = new ECCI.ECCI_B77519_B72097_GatoPortClient();
            cronometro = new Stopwatch();
        }

        private void EmpezarTurno() {
            Casilla1.Show();
            Casilla2.Show();
            Casilla3.Show();
            Casilla4.Show();
            Casilla5.Show();
            Casilla6.Show();
            Casilla7.Show();
            Casilla8.Show();
            Casilla9.Show();
            btn_jugar.Hide();
            textBox1.Hide();
            label3.Hide();

            label1.Text += textBox1.Text;
        }

        private void SeguirJugando()
        {
            Casilla1.Text = "";
            Casilla2.Text = "";
            Casilla3.Text = "";
            Casilla4.Text = "";
            Casilla5.Text = "";
            Casilla6.Text = "";
            Casilla7.Text = "";
            Casilla8.Text = "";
            Casilla9.Text = "";

            btn_jugar.Hide();
        }
        private void ReiniciarTurno(string resultado) {
            cronometro.Stop();

            TimeSpan stopwatchElapsed = cronometro.Elapsed;
            int duracion = Convert.ToInt32(stopwatchElapsed.TotalSeconds);

            if (resultado.Contains("GANADO")) {
                gato.reiniciar(duracion);
            }

            MessageBox.Show(resultado + "\nDuracion del turno: " + duracion+" segundos");

            cronometro.Reset();
        }


        private void btn_jugar_Click(object sender, EventArgs e)
        {
            if (btn_jugar.Text == "Empezar")
            {
                EmpezarTurno();
                gato.setJugador(textBox1.Text);
            }
            else
            {
                SeguirJugando();
            }

            cronometro.Start();
        }

        private void Jugar(int jugada)
        {
            switch (jugada)
            {
                case 0:
                    Casilla1.Text = "O";
                    break;
                case 1:
                    Casilla2.Text = "O";
                    break;
                case 2:
                    Casilla3.Text = "O";
                    break;
                case 3:
                    Casilla4.Text = "O";
                    break;
                case 4:
                    Casilla5.Text = "O";
                    break;
                case 5:
                    Casilla6.Text = "O";
                    break;
                case 6:
                    Casilla7.Text = "O";
                    break;
                case 7:
                    Casilla8.Text = "O";
                    break;
                case 8:
                    Casilla9.Text = "O";
                    break;

            }
        }


        private void Presionado(int movimiento)
        {
            gato.jugar(movimiento);

            if (gato.checkWin(movimiento, "X"))
            {
                ReiniciarTurno("FELICIDADES, HAS GANADO");
                btn_jugar.Show();
                btn_jugar.Text = "¿Volver a jugar?";
            }
            else
            {

                if (gato.getCasillasRestantes() == 0)
                {
                    ReiniciarTurno("Has empatado, mas suerte la proxima");
                    btn_jugar.Show();
                    btn_jugar.Text = "¿Volver a jugar?";
                }

                else
                {
                    var jugada = gato.juegaMaquina();
                        
                    Jugar(jugada);
                    if (gato.checkWin(jugada, "O"))
                    {
                        ReiniciarTurno("Has perdido");
                        btn_jugar.Show();
                        btn_jugar.Text = "¿Volver a jugar?";
                    }
                    else
                    {
                        if (gato.getCasillasRestantes() == 0)
                        {
                            ReiniciarTurno("Has empatado, mas suerte la proxima");
                            btn_jugar.Show();
                            btn_jugar.Text = "¿Volver a jugar?";
                        }
                    }
                }

            }

        }

        private void Casilla1_Click(object sender, EventArgs e)
        {
            if (Casilla1.Text.Equals(""))
            {
                Casilla1.Text = "X";
                Presionado(0);
            }
        }

        private void Casilla2_Click(object sender, EventArgs e)
        {
            if (Casilla2.Text.Equals(""))
            {
                Casilla2.Text = "X";
                Presionado(1);
            }
        }

        private void Casilla3_Click(object sender, EventArgs e)
        {
            if (Casilla3.Text.Equals(""))
            {
                Casilla3.Text = "X";
                Presionado(2);
            }
        }

        private void Casilla4_Click(object sender, EventArgs e)
        {
            if (Casilla4.Text.Equals(""))
            {
                Casilla4.Text = "X";
                Presionado(3);
            }
        }

        private void Casilla5_Click(object sender, EventArgs e)
        {
            if (Casilla5.Text.Equals(""))
            {
                Casilla5.Text = "X";
                Presionado(4);
            }
        }

        private void Casilla6_Click(object sender, EventArgs e)
        {
            if (Casilla6.Text.Equals(""))
            {
                Casilla6.Text = "X";
                Presionado(5);
            }
        }

        private void Casilla7_Click(object sender, EventArgs e)
        {
            if (Casilla7.Text.Equals(""))
            {
                Casilla7.Text = "X";
                Presionado(6);

            }
        }

        private void Casilla8_Click(object sender, EventArgs e)
        {
            if (Casilla8.Text.Equals(""))
            {
                Casilla8.Text = "X";
                Presionado(7);

            }
        }

        private void Casilla9_Click(object sender, EventArgs e)
        {
            if (Casilla9.Text.Equals(""))
            {
                Casilla9.Text = "X";
                Presionado(8);

            }
        }

        private void top_Click(object sender, EventArgs e)
        {
            top.Text = "Actualizar";
            List<int> tempTiempos = new List<int>();
            List<string> tempJugadores = new List<string>();

            if (gato.getRecordJugadores() == "") {
                gato.guardarRecords();
            }

            getTop.Text = "";
            


            string[] topJugadores = gato.getTop().Split('\n');

            for (int i = 0; i < topJugadores.Length; i++) {
                string[] temp = topJugadores[i].Split(':');
                tempJugadores.Add(temp[0]);
                tempTiempos.Add(Convert.ToInt32(temp[1]));
            }

            List<int> tiempos = tempTiempos;

            for (int i = 0; i < 10; i++)
            {
                int minIndex = tempTiempos.IndexOf(tempTiempos.Where(x => x >= 0).Min());

                getTop.Text += "#-" + (i + 1) + " " + tempJugadores[minIndex] +" "+ tempTiempos[minIndex]+ " segundos\n";

                tempTiempos[minIndex] = -1;
            }

        }
    }
}